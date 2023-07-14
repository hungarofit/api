package main

import (
	"encoding/json"
	"fmt"
	"log"
	"net/http"
	"os"
	"strconv"
	"strings"

	hfit "github.com/hungarofit/evaluator"
)

type results map[string]hfit.ResultValue

type reqEvaluate struct {
	Challenge hfit.Challenge `json:"challenge"`
	Gender    hfit.Gender    `json:"gender"`
	Age       hfit.Age       `json:"age"`
	Results   results        `json:"results"`
}

func httpErr(w http.ResponseWriter, err error) bool {
	if err != nil {
		log.Println(err)
		w.WriteHeader(500)
		err2 := json.NewEncoder(w).Encode(map[string]interface{}{
			"error": err.Error(),
		})
		if err2 != nil {
			log.Println(err2)
		}
		return true
	}
	return false
}

func httpOk(w http.ResponseWriter, any interface{}) {
	w.WriteHeader(200)
	err2 := json.NewEncoder(w).Encode(any)
	if err2 != nil {
		log.Println(err2)
	}
}

func handleIndex(w http.ResponseWriter, r *http.Request) {
	w.WriteHeader(200)
	w.Write([]byte("Ok."))
}

func handleEvaluate(w http.ResponseWriter, r *http.Request) {
	if r.ContentLength < 1 {
		httpErr(w, fmt.Errorf("request body is empty"))
		return
	}
	var t reqEvaluate
	decoder := json.NewDecoder(r.Body)
	if err := decoder.Decode(&t); err != nil {
		httpErr(w, err)
		return
	}
	results := map[hfit.Exercise]hfit.ResultValue{}
	for ex, v := range t.Results {
		if strings.HasPrefix(ex, "aerob-") {
			results[hfit.Exercise(ex)] = v
			continue
		}
		results[hfit.Exercise(string(t.Challenge)+"-"+string(ex))] = v
	}
	score, err := hfit.Evaluate(t.Challenge, t.Gender, t.Age, results)
	if err != nil {
		httpErr(w, err)
		return
	}
	httpOk(w, score)
	log.Printf("%#v\n", score)
}

func main() {
	var port uint16 = 8080
	if envPort := os.Getenv("HTTP_PORT"); envPort != "" {
		port2, err := strconv.ParseInt(envPort, 10, 32)
		if err != nil {
			log.Fatalln(err)
		}
		port = uint16(port2)
	}
	mux := http.NewServeMux()
	mux.HandleFunc("/", handleIndex)
	mux.HandleFunc("/evaluate", handleEvaluate)
	log.Printf("Starting server on http://localhost:%d", port)
	http.ListenAndServe(fmt.Sprintf(":%d", port), http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
		w.Header().Set("Access-Control-Allow-Origin", "*")
		mux.ServeHTTP(w, r)
	}))
}
