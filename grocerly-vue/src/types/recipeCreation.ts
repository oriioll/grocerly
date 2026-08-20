import type { Food } from './food'

export interface RecipeFoodInput {
  food: Food & { id: number }
  grams: number
}

export interface RecipeCreationPayload {
  name: string
  is_public: boolean
  servings: number
  foods: Array<{
    food_id: number
    grams: number
  }>
}
