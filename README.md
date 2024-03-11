# api

## HTTP API for Hungarofit evaluator

Based on [chi](github.com/go-chi/chi) and [huma](https://github.com/danielgtaylor/huma)


### Usage

#### Help

Navigating to `/docs` shows the OpenAPI documentation.

```bash
docker run ghcr.io/hungarofit/api:latest -h
```

```
Usage:
  api [flags]

Flags:
  -h, --help                        help for api
  -H, --host string                  (default "0.0.0.0")
  -P, --port int                     (default 8080)
  -t, --shutdown-timeout duration    (default 10s)
```


#### Basic

```bash
docker run -p 8080:8080 \
    ghcr.io/hungarofit/api:latest
```


#### Options from environment

```bash
docker run -p 8080:8080 \
    -e SERVICE_HOST=0.0.0.0 \
    -e SERVICE_PORT=8080 \
    -e SERVICE_SHUTDOWN_TIMEOUT=10s \
    ghcr.io/hungarofit/api:latest
```


#### Options from arguments

```bash
docker run -p 8080:8080 \
    ghcr.io/hungarofit/api:latest \
    --host=0.0.0.0 \
    --port=8080 \
    --shutdown-timeout=10s
```


### Example requests

#### Hungarofit

```json
{
  "challenge": "hfit6",
  "age": 24,
  "gender": "female",
  "exercises": [
    {
      "name": "aerob-swim-12min",
      "result": 500
    },
    {
      "name": "jump",
      "result": 1.92
    },
    {
      "name": "pushup",
      "result": 20
    },
    {
      "name": "situp",
      "result": 80
    },
    {
      "name": "torso",
      "result": 80
    },
    {
      "name": "throwdouble",
      "result": 1.92
    },
    {
      "name": "throwsingle",
      "result": 11.1
    }
  ]
}
```


#### Hungarofit Mini

```json
{
  "challenge": "hfit4",
  "age": 24,
  "gender": "female",
  "exercises": [
    {
      "name": "aerob-swim-12min",
      "result": 500
    },
    {
      "name": "jump",
      "result": 1.92
    },
    {
      "name": "pushup",
      "result": 20
    },
    {
      "name": "situp",
      "result": 80
    },
    {
      "name": "torso",
      "result": 80
    }
  ]
}
```


### Example response

```json
{
  "$schema": "http://localhost:8080/schemas/EvaluateOutputBody.json",
  "total": 73,
  "total_max": 140,
  "exercises": {
    "jump": {
      "score": 11,
      "score_max": 21
    },
    "pushup": {
      "score": 9,
      "score_max": 14
    },
    "situp": {
      "score": 7,
      "score_max": 14
    },
    "swim-12min": {
      "score": 39,
      "score_max": 77
    },
    "torso": {
      "score": 7,
      "score_max": 14
    }
  }
}
```