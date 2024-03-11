package routes

import (
	"context"
	"net/http"

	"github.com/danielgtaylor/huma/v2"
)

type HealhtzOutput struct {
	Body []byte `example:"Ok."`
}

func callbackHealhtz(ctx context.Context, i *struct{}) (*HealhtzOutput, error) {
	return &HealhtzOutput{
		Body: []byte("Ok."),
	}, nil
}

func RegisterHealhtz(api huma.API) error {
	huma.Register(
		api,
		huma.Operation{
			OperationID: "healthz",
			Summary:     "Health",
			Description: "Used by automated healthchecks",
			Method:      http.MethodGet,
			Path:        "/healthz",
			Tags:        []string{"internal"},
		},
		callbackHealhtz,
	)
	return nil
}
