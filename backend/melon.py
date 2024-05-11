import requests
from bs4 import BeautifulSoup
import re
import pandas as pd

#%%
order = ['rank_wrap_p','rank_p','title_p','artist_p','album_p','release_p','album_img_p']
rank_wrap_p = []
rank_p = []
title_p = []
artist_p = []
album_p = []
release_p = []
album_img_p = []


url = 'https://www.melon.com/chart/index.htm'

headers = {
        'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
    }

response = requests.get(url, headers=headers)
if response.status_code == 200:
    soup = BeautifulSoup(response.text, 'html.parser')
    song_tags = soup.select('.service_list_song table tbody tr')
    
    
    
    for song_tag in song_tags:
        rank = song_tag.select_one('.rank').text.strip()
        rank_wrap = song_tag.select_one('.rank_wrap').text.strip()
        rank_wrap = rank_wrap.split()
        if '하락' in rank_wrap:
            rank_wrap = rank_wrap[2] + ' Down'
        elif '상승' in rank_wrap:
            rank_wrap = rank_wrap[2] + ' Up'
        elif '동일' in rank_wrap:
            rank_wrap = 'Same'
        elif '진입' in rank_wrap:
            rank_wrap = 'New'
        
        title = song_tag.select_one('.ellipsis.rank01 a').text.strip()
        artist = song_tag.select_one('.ellipsis.rank02 a').text.strip()
        album = song_tag.select_one('.ellipsis.rank03 a').text.strip()
        album_num = song_tag.select_one('.image_typeAll')
        href_value = album_num['href'] if album_num else ''
        album_id_match = re.search(r"(\d+)", href_value)
        album_id = album_id_match.group(1)
        detail_url = f'https://www.melon.com/album/detail.htm?albumId={album_id}'
    
        res = requests.get(detail_url, headers=headers)
        soup = BeautifulSoup(res.text, 'html.parser')
        album_img = soup.select_one('a.image_typeAll img')
        src_value = album_img.get('src', '')
        song_di = soup.select("div.meta dd")
        release = song_di[0].text
        print(f'{rank_wrap} | {rank}.  {title} - {artist} | {album} | {release}')
        rank_wrap_p.append(rank_wrap)
        rank_p.append(rank)
        title_p.append(title)
        artist_p.append(artist)
        album_p.append(album)
        release_p.append(release)
        album_img_p.append(src_value)
#%%        
for i in order:
    globals()['{}'.format(i)] = pd.Series(globals()['{}'.format(i)])
total = pd.concat([rank_wrap_p,rank_p,title_p,artist_p,album_p,release_p,album_img_p],axis = 1)
total = total.rename(columns={0: 'rank_wrap', 1: 'rank', 2: 'title', 3: 'artist', 4: 'album', 5: 'release', 6: 'thumbnail'})
# js = total.to_json("D:/폐기/result/result_top100.json",orient="records")
json_result = total.to_json(orient="records")
print(json_result)