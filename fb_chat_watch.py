#!/usr/bin/env python3
# -*- coding: utf-8 -*-
from selenium import webdriver
from urllib.parse import urlparse, parse_qs
import getpass
import datetime
import time

# driver=webdriver.Firefox()
driver=webdriver.PhantomJS()
driver.set_window_size(320, 568)
# facebook mobile
driver.get('https://mbasic.facebook.com')

print('Facebook Login')
fb_email = input('email: ')
driver.find_element_by_name('email').send_keys(fb_email)
fb_pass = getpass.getpass('password: ')
driver.find_element_by_name('pass').send_keys(fb_pass)
driver.find_element_by_name('login').click()

with open('log.txt', 'a', encoding = "utf-8") as logfile:
	t = 0
	while 1:
		t += 1
		# go to Chat tab
		driver.get('https://mbasic.facebook.com/buddylist.php')
		print(datetime.datetime.now(), file=logfile)
		# sleep a while to wait for loading
		time.sleep(1)
		friends = ''
		# online users are A tags with .bu class name
		for i in driver.find_elements_by_css_selector('a.bt'):
			friends += i.text + '#'
			friends += parse_qs(urlparse(i.get_attribute('href')).query)['fbid'][0] + '\n'
		friends += '\n'
		print(friends, file=logfile)
		print(t, 'th cycle completed at', datetime.datetime.now())
		time.sleep(60)

