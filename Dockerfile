FROM golang:1.21-alpine as builder
WORKDIR /app
COPY . .
RUN go mod tidy
RUN CGO_ENABLED=0 GOOS=linux GOARCH=amd64 go build -ldflags "-w -s" -o app .

FROM scratch
COPY --from=builder /app/app /usr/bin/
EXPOSE 8080

ENTRYPOINT [ "/usr/bin/app" ]
