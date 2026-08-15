import type { Food } from './food'

export interface ShoppingList {
  listId: number | null
  userId: number
  foods: Food[]
}
