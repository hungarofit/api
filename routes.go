package main

import (
	"github.com/danielgtaylor/huma/v2"
	"github.com/hungarofit/api/routes"
)

func registerRoutesList(api huma.API, routes ...func(api huma.API) error) error {
	for _, route := range routes {
		if err := route(api); err != nil {
			return err
		}
	}
	return nil
}

func registerRoutes(api huma.API) error {
	return registerRoutesList(
		api,
		routes.RegisterIndex,
		routes.RegisterHealhtz,
		routes.RegisterEvaluate,
	)
}
