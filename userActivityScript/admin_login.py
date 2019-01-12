from selenium import webdriver
import time
server = 'http://localhost/login.php'
def main():
    global driver
    driver = webdriver.Firefox(executable_path='/var/www/html/Website/geckodriver')

    driver.set_page_load_timeout(5)
    driver.get(server)
    for i in range(2):
        try:
            login()
        except:
            pass
        time.sleep(5)
    driver.close()

def login():
    username = driver.find_element_by_name("username")
    password = driver.find_element_by_name("password")

    username.send_keys("adm")
    password.send_keys("Th!sIsPA$$w0rd")

    # driver.find_element_by_id("submit").click()

    driver.find_element_by_css_selector('.main-button').click()

if __name__ == '__main__':
    main()
