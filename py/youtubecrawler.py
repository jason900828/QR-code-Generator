
import requests
from bs4 import BeautifulSoup
import sys
url = sys.argv[1]
r = requests.get(url)
c = r.content
soup = BeautifulSoup(c,"html.parser")
title = soup.title.get_text().replace(' - YouTube','')

print(title)