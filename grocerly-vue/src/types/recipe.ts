import type { Food } from './food'

export interface Recipe {
  id: number | null
  name: string
  isPublic: boolean
  servings: number
  foods: Food[]
}
