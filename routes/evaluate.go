package routes

import (
	"context"
	"net/http"
	"strings"

	"github.com/danielgtaylor/huma/v2"
	"github.com/hungarofit/evaluator"
)

type EvaluateInputExercise struct {
	Name   string  `json:"name" example:"situp" doc:"Name of the exercise"`
	Result float32 `json:"result" min:"0" example:"1.92" doc:"Score of the exercise (use minutes.seconds for time units)"`
}

type EvaluateInputBody struct {
	Age       int                     `json:"age" min:"4" example:"24" doc:"Age of the participant"`
	Gender    string                  `json:"gender" enum:"female,male" example:"female" doc:"Biological sex of the participant"`
	Challenge string                  `json:"challenge" enum:"hfit4,hfit6" example:"hfit4" doc:"Type of challenge"`
	Exercises []EvaluateInputExercise `json:"exercises" doc:"Results of the exercises performed by the participant"`
}

type EvaluateInput struct {
	Body EvaluateInputBody
}

type EvaluateOutputBody struct {
	Total     float32                           `json:"total" example:"101" doc:"Final score"`
	TotalMax  float32                           `json:"total_max" example:"140" doc:"Maximum score possible"`
	Exercises map[string]EvaluateOutputExercise `json:"exercises" doc:"Scores acheived on the exercises"`
}

type EvaluateOutput struct {
	Body EvaluateOutputBody
}

type EvaluateOutputExercise struct {
	Score    float32 `json:"score" example:"50.5" doc:"Score on the exercise"`
	ScoreMax float32 `json:"score_max" example:"70" doc:"Maximum score possible"`
}

func callbackEvaluate(ctx context.Context, input *EvaluateInput) (*EvaluateOutput, error) {
	challenge := evaluator.ChallengeHungarofit
	if input.Body.Challenge == "hfit4" {
		challenge = evaluator.ChallengeHungarofitMini
	}
	gender := evaluator.GenderUnknown
	switch input.Body.Gender {
	case "female":
		gender = evaluator.GenderFemale
	case "male":
		gender = evaluator.GenderMale
	}
	results := map[evaluator.Exercise]evaluator.ResultValue{}
	for _, value := range input.Body.Exercises {
		results[evaluator.Exercise(value.Name)] = evaluator.ResultValue(value.Result)
	}
	score, err := evaluator.Evaluate(challenge, gender, evaluator.Age(input.Body.Age), results)
	output := EvaluateOutput{}
	output.Body.Total = float32(score.Total)
	output.Body.TotalMax = float32(score.TotalMax)
	output.Body.Exercises = map[string]EvaluateOutputExercise{}
	for exercise, result := range score.Exercises {
		val := EvaluateOutputExercise{
			Score:    float32(result.Score),
			ScoreMax: float32(result.ScoreMax),
		}
		exerciseName := exercise.GetName()
		if exercise.GetType() != evaluator.ExerciseTypeAerob {
			exerciseName = strings.Replace(exerciseName, string(evaluator.ChallengeHungarofit)+"-", "", 1)
			exerciseName = strings.Replace(exerciseName, string(evaluator.ChallengeHungarofitMini)+"-", "", 1)
		}
		output.Body.Exercises[exerciseName] = val
	}
	return &output, err
}

func RegisterEvaluate(api huma.API) error {
	huma.Register(
		api,
		huma.Operation{
			OperationID: "evaluate",
			Summary:     "Evaluate",
			Description: "Use to evaluate the results of an individual on a specific challenge",
			Method:      http.MethodPost,
			Path:        "/evaluate",
		},
		callbackEvaluate,
	)
	return nil
}
