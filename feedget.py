#! /usr/bin/pyton
import urllib
response = urllib.urlopen('http://198.58.96.27/phpBB3/feed.php')
html = response.read()
end= 5
edit = html
run=1
fi = open("/var/www/sites/scioly.org/public/ticker.html", "wb")
while (run<=6):
	first=edit.find("<category term")
	
	tmp=edit[first+14:]
	end=tmp.find("</title>")
	tmp=tmp[:end]
	start_author=tmp.find("<author><name><![CDATA[")
	end_author=tmp.find("]]></name></author>")
	author=tmp[start_author+23:end_author]
	link_start=tmp.find("<link ")
	tmp_tmp=tmp[link_start:]
	link_end=tmp_tmp.find("<title type=\"html\">")
	link_end=link_end+link_start
	link=tmp[link_start+12:link_end-4]
	link=link.replace('198.58.96.27','scioly.org')
	where_start=tmp.find("<title type=\"html\"><![CDATA[")
	where=tmp[where_start+28:]
	where_len=len(where)
	where=where[:where_len-3]
	just_title_start=where.find("Re:")
	just_title=where[just_title_start+4:]
	url= author+" Posted in <a href="+link+">"+just_title+"</a><br/>"
	#print url
	fi.write(url)
	edit=edit[first+14+end+8:]
	run+=1
	#print "-------------------------------------------------------------------"
	
fi.close()	
#print html
