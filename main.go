package main

import (
	"context"
	"fmt"
	"net/http"

	"github.com/danielgtaylor/huma/v2"
	"github.com/danielgtaylor/huma/v2/adapters/humachi"
	"github.com/go-chi/chi/v5"
)

func main() {
	// Create a CLI app which takes a port option.
	cli := huma.NewCLI(func(hooks huma.Hooks, options *Options) {
		// Create a new router & API
		router := chi.NewMux()
		humaConfig := huma.DefaultConfig("Hungarofit API", "v1")
		humaConfig.Info.Description = "HTTP API for Hungarofit evaluator"
		api := humachi.New(router, humaConfig)

		// Register routes
		if err := registerRoutes(api); err != nil {
			fmt.Println(err)
		}

		// Create the HTTP server.
		listenAddress := fmt.Sprintf("%s:%d", options.Host, options.Port)
		server := http.Server{
			Addr:    listenAddress,
			Handler: router,
		}
		printAddress := listenAddress
		if options.Host == "" || options.Host == "0.0.0.0" {
			printAddress = fmt.Sprintf("http://localhost:%d", options.Port)
		}
		fmt.Println("Listen address:", printAddress)

		// Tell the CLI how to start your router.
		hooks.OnStart(func() {
			fmt.Println("Starting server...")
			if err := server.ListenAndServe(); err != nil {
				fmt.Println(err)
			}
		})

		// Tell the CLI how to stop your server.
		hooks.OnStop(func() {
			fmt.Println("Stopping server...")
			ctx, cancel := context.WithTimeout(context.Background(), options.ShutdownTimeout)
			defer cancel()
			server.Shutdown(ctx)
		})
	})

	// Run the CLI. When passed no commands, it starts the server.
	cli.Run()
}
