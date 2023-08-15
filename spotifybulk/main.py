try:
	import requests as x, json, random, os, threading, sys
except Exception as e :
	print(" Module belum terinstall\n")

class Spotify:
	
	def __init__(self):
		self.api = x.Session()
	
	def user_data(self):
		return self.api.get("http://api.suhu.my.id/v2/faker",headers={"User-Agent": "PanelNewbie/0.2 (Linux; rdhoni;) Termux/0.2"}).json()
	
	def create(self, ua, nama, email, sandi, ttl, gender):
		return self.api.post("https://spclient.wg.spotify.com/signup/public/v2/account/create", json={"account_details":{"birthdate":ttl,"consent_flags":{"eula_agreed":True,"send_email":False,"third_party_email":False},"display_name":nama,"email_and_password_identifier":{"email":email,"password":sandi},"gender":gender},"callback_uri":"","client_info":{"api_key":"a2d4b979dc624757b4fb47de483f3505","app_version":"v2","capabilities":[1],"installation_id":"","platform":""},"tracking":{"creation_flow":"","creation_point":"","referrer":""},"recaptcha_token":"","submission_id":""}, headers={"User-Agent":ua,"Content-Type":"application/json"})

class UserThread:
    def main(self, domain, sandi):
        generate_data = Spotify().user_data()
        ua = generate_data["browser"]["user_agent"]
        nama = generate_data["email"]
        nama = nama.split("@")[0]
        gender = random.randint(1, 4)
        email = f'{nama.replace(" ","")}{domain}'.lower()
        ttl = f"{random.randint(1990, 2002)}-{random.randint(10, 12)}-{random.randint(10, 31)}"
        signup = Spotify().create(ua, nama, email, sandi, ttl, gender)
        # print(signup.text)
        if "login_token" in signup.text:
            print(f" Created : {email}")
            with open('account.txt', 'a') as f:
            	f.write(f'Email : {email} | Sandi : {sandi}\n')
        elif "challenge" in signup.text:
            print(" Error while registering, airplane mode")
        else:
            None

    def createThread(self):
        try:
            domain = "@shutupfvckup.my.id"  # set domain here
            sandi = "chsangkara"  # set password here

            try:
                amount = input(f' Amount : ')
                if int(amount) > 20:  # jangan diganti biar ga error spam
                    sys.exit(f'\n Sebaiknya jangan gegabah terlalu banyak')
                else:
                    print(f"\n Ready Create Spotify Account\n\n Kata sandi : {sandi}\n")
                threads = []
                count = 0
                try:
                    while count < int(amount):
                        thread = threading.Thread(target=self.main, args=(domain, sandi))
                        threads.append(thread)
                        thread.start()
                        count += 1
                     
                    for thread in threads:
                        thread.join()
                     
                    print("\n Support : 0895415306281 ( DANA )\n") # Credit jangan dihapus kontol
                    
                except KeyboardInterrupt:
                    pass

            except Exception as r:
                None

        except Exception as r:
            None

    def user_main(self):
        green = "\033[0;32m"
        white = "\033[0;37m"
        os.system('cls' if os.name == "nt" else 'clear')
        print(f"{green}\n\n  ()                       \n  /\          _/_   /)     \n /  )  _   __ /  o // __  ,\n/__/__/_)_(_)<__<_//_/ (_/_ {white}  Agathasangkara{green}\n     /           />     /  \n    '           </     '   \n{white}\n"); UserThread().createThread()
        
if __name__ == "__main__":
    index = UserThread().user_main()
