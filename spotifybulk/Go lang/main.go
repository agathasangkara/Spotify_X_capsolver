package main

import (
	"bytes"
	"context"
	"encoding/json"
	"errors"
	"fmt"
	"io"
	"net/http"
	"time"
)

type capSolverResponse struct {
	ErrorId          int32          `json:"errorId"`
	ErrorCode        string         `json:"errorCode"`
	ErrorDescription string         `json:"errorDescription"`
	TaskId           string         `json:"taskId"`
	Status           string         `json:"status"`
	Solution         map[string]any `json:"solution"`
}

func capSolver(ctx context.Context, apiKey string, taskData map[string]any) (*capSolverResponse, error) {
	uri := "https://api.capsolver.com/createTask"
	res, err := request(ctx, uri, map[string]any{
		"clientKey": apiKey,
		"task":      taskData,
	})
	if err != nil {
		return nil, err
	}
	if res.ErrorId == 1 {
		return nil, errors.New(res.ErrorDescription)
	}

	uri = "https://api.capsolver.com/getTaskResult"
	for {
		select {
		case <-ctx.Done():
			return res, errors.New("solve timeout")
		case <-time.After(time.Second):
			break
		}
		res, err = request(ctx, uri, map[string]any{
			"clientKey": apiKey,
			"taskId":    res.TaskId,
		})
		if err != nil {
			return nil, err
		}
		if res.ErrorId == 1 {
			return nil, errors.New(res.ErrorDescription)
		}
		if res.Status == "ready" {
			return res, err
		}
	}
}

func request(ctx context.Context, uri string, payload interface{}) (*capSolverResponse, error) {
	payloadBytes, err := json.Marshal(payload)
	if err != nil {
		return nil, err
	}
	req, err := http.NewRequestWithContext(ctx, "POST", uri, bytes.NewReader(payloadBytes))
	if err != nil {
		return nil, err
	}
	req.Header.Set("Content-Type", "application/json")
	client := &http.Client{}
	resp, err := client.Do(req)
	if err != nil {
		return nil, err
	}
	defer resp.Body.Close()
	responseData, err := io.ReadAll(resp.Body)
	if err != nil {
		return nil, err
	}
	capResponse := &capSolverResponse{}
	err = json.Unmarshal(responseData, capResponse)
	if err != nil {
		return nil, err
	}
	return capResponse, nil
}

func main() {
	apikey := "CAP-5D0AF3E2F4B177CFDC3AEAC80163DE0A"
	ctx, cancel := context.WithTimeout(context.Background(), time.Second*120)
	defer cancel()

	res, err := capSolver(ctx, apikey, map[string]any{
		"type":       "ReCaptchaV2TaskProxyLess",
		"websiteURL": "https://www.google.com/recaptcha/api2/demo",
		"websiteKey": "6Le-wvkSAAAAAPBMRTvw0Q4Muexq9bi0DJwx_mJ-",
	})
	if err != nil {
		panic(err)
	}
	fmt.Println(res.Solution["gRecaptchaResponse"])
}
type SpotifyAPI struct {
	Client   *http.Client
	Proxies  []string
	Password string
}

func NewSpotifyAPI(proxies []string, password string) *SpotifyAPI {
	return &SpotifyAPI{
		Client:   &http.Client{},
		Password: password,
	}
}

func (s *SpotifyAPI) create(username string) (string, error) {
	data := fmt.Sprintf("password_repeat=%s&displayname=%s&password=%s&birth_month=%02d&key=142b583129b2df829de3656f9eb484e6&birth_day=%02d&iagree=true&creation_point=client_mobile&platform=Android-ARM&birth_year=%d&gender=neutral&email=%s@chsangkara.com",
		s.Password,
		username,
		s.Password,
		rand.Intn(12)+1,
		rand.Intn(30)+1,
		rand.Intn(21)+1980,
		username,
	)

	headers := map[string]string{
		"content-type": "application/x-www-form-urlencoded",
		"user-agent":   "Spotify/8.9.10 Android/30 (Samsung S23 Ultra)",
		"app-platform": "Android",
	}

	// proxy := ""
	// if len(s.Proxies) > 0 {
	// 	rand.Seed(time.Now().UnixNano())
	// 	proxy = s.Proxies[rand.Intn(len(s.Proxies))]
	// }

	req, err := http.NewRequest("POST", "https://spclient.wg.spotify.com/signup/public/v1/account/", bytes.NewBufferString(data))
	if err != nil {
		return "", err
	}

	for key, value := range headers {
		req.Header.Set(key, value)
	}

	// if proxy != "" {
	// 	transport := &http.Transport{
	// 		Proxy: http.ProxyURL(&url.URL{
	// 			Scheme: "http",
	// 			Host:   proxy,
	// 		}),
	// 	}
	// 	s.Client.Transport = transport
	// }

	resp, err := s.Client.Do(req)
	if err != nil {
		return "", err
	}
	defer resp.Body.Close()

	body, err := ioutil.ReadAll(resp.Body)
	if err != nil {
		return "", err
	}

	return string(body), nil
}

type CreateResponse struct {
	Status float64 `json:"status"`
	Errors string  `json:"error"`
}

func main() {
	fmt.Print("\033[H\033[2J")
	fmt.Print(`
    _   _   _   _   _   _   _  
   / \ / \ / \ / \ / \ / \ / \ 
  ( S | p | o | t | i | f | y ) Spotify Account Creator x t.me/chsangkara
   \_/ \_/ \_/ \_/ \_/ \_/ \_/ 
 ` + "\n")

	password := "Tasik12345"
	utilsClient := NewSpotifyAPI(nil, password)

	file, _ := os.OpenFile("spotify_acc.txt", os.O_APPEND|os.O_WRONLY|os.O_CREATE, 0644)
	defer file.Close()

	var count, amount int
	fmt.Print("   > Amount of Account : ")
	fmt.Scan(&amount)

	color.New(color.FgYellow).Println("\n   > Processing create " + fmt.Sprint(amount) + " Account\n")
	for i := 0; i < amount; i++ {
		first, _ := GetUsername("username.txt")
		last, _ := GetUsername("username.txt")
		first = strings.TrimSpace(first)
		last = strings.TrimSpace(last)

		uname := first + last
		username := strings.ToLower(uname + strconv.Itoa(rand.Intn(1000)))
		create, err := utilsClient.create(username)
		if err != nil {
			fmt.Println(err)
			return
		}
		var createResponse CreateResponse

		json.Unmarshal([]byte(create), &createResponse)

		if createResponse.Status == 1 {
			color.New(color.FgGreen).Println("   > Email : " + username + "@dudsstore.com" + " | " + "Password : " + password + " | CREATE ACCOUNT SUCCESS")
			fmt.Fprintf(file, "Email : %s@dudsstore.com | Password : %s | CREATE ACCOUNT SUCCESS\n", username, password)
			count++
		} else {
			color.New(color.FgRed).Println("   > Email : " + username + "@chsangkara.com" + " | " + "Password : " + password + " | CREATE ACCOUNT FAILED")
		}
	}
}

func GetUsername(filename string) (string, error) {
	content, err := ioutil.ReadFile(filename)
	if err != nil {
		return "", err
	}

	usernames := strings.Split(string(content), "\n")
	randomIndex := rand.Intn(len(usernames))
	return usernames[randomIndex], nil
}
