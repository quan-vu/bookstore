import subprocess
import time

def ls():
    subprocess.run(["ls", "-l"])

def index_all_books():
    for i in range(1, 10000):
        print(f"======== {i}: Started ==========")
        subprocess.run(["docker-compose", "exec", "api", "php", "artisan", "elastic:index-books", "5000"])
        print(f"======== {i}: Sleep 5s ==========")
        time.sleep(5)


if __name__ == '__main__':
    index_all_books()
