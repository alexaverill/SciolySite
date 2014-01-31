#! /usr/bin/pyton
import urllib
response = urllib.urlopen('http://198.58.96.27/wiki/index.php?title=Special:RecentChanges&feed=rss&limit=50')
html = response.read()
end= 5
edit = html
run=1
fi = open("/var/www/sites/scioly.org/public/wiki_ticker.html", "wb")
while (run<=6):
	first=edit.find("<item>")
	
	tmp=edit[first+6:]
	end=tmp.find("</item>")
	tmp=tmp[:end]
	start_title=tmp.find("<title>")
	end_title=tmp.find("</title>")
	title=tmp[start_title+7:end_title]
	link_start=tmp.find("<link>")
	link_end=tmp.find("</link>")
	link=tmp[link_start+6:link_end]
	link_clean=link.find("diff=")
	link=link[:link_clean-5]
	link=link.replace('198.58.96.27','scioly.org')
	

	url= "<a href="+link+">"+title+"</a> was edited.<br/>"
	#print url
	fi.write(url)
	edit=edit[end+7:]
	run+=1
	#print "-------------------------------------------------------------------"
	
fi.close()	
