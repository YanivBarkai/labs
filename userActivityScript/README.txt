Script usage (use this script on Linux Ubuntu server):

1. Install all neccessary repos for selenium on Linux (find full explanation [here](https://medium.com/@griggheo/running-selenium-webdriver-tests-using-firefox-headless-mode-on-ubuntu-d32500bb6af2))

```
sudo apt-add-repository ppa:mozillateam/firefox-next
sudo apt-get update
sudo apt-get install firefox xvfb
```

2. Run virtual desktop:

```
Xvfb :10 -ac &
```

3. Export display variable

```
export DISPLAY=:10
```
