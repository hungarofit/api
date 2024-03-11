package main

import "time"

// Options for the CLI.
type Options struct {
	Host            string        `help:"Addres to listen on" short:"H" default:"0.0.0.0"`
	Port            int           `help:"Port to listen on" short:"P" default:"8080"`
	ShutdownTimeout time.Duration `help:"Shutdown timeout in duration" short:"t" default:"10s"`
}
