package routes

import (
	"context"
	"net/http"

	"github.com/danielgtaylor/huma/v2"
)

type IndexOutput struct {
	Location string `header:"Location"`
}

func callbackIndex(ctx context.Context, i *struct{}) (*IndexOutput, error) {
	return &IndexOutput{
		Location: "/docs",
	}, nil
}

func RegisterIndex(api huma.API) error {
	huma.Register(
		api,
		huma.Operation{
			OperationID:   "index",
			Summary:       "Index",
			Description:   "Redirects to /docs page",
			Method:        http.MethodGet,
			Path:          "/",
			DefaultStatus: 302, // temp redir
			Tags:          []string{"internal"},
		},
		callbackIndex,
	)
	return nil
}
