/// <reference types="vite/client" />

import type { Recipe } from '../types/recipe'
import type { RecipeCreationPayload } from '../types/recipeCreation'

export class RecipeService {
  private readonly BASE_URL = import.meta.env.VITE_API_BASE_URL?.replace(/\/$/, '') || ''

  /**
   * Makes a GET request to the API to get all the recipes from the user
   * @returns The API response
   * @author Oriol Plazas
   * @since 15/08/2026
   */
  public async getMyRecipes(): Promise<Recipe[]> {
    const token = localStorage.getItem('token')
    if (!token) {
      throw new Error('No token available to get the user')
    }
    const url: string = `${this.BASE_URL}/recipes/me`
    const response = await fetch(url, {
      method: 'GET',
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
      },
    })

    if (!response.ok) {
      const errorText = await response.text()
      throw new Error(errorText || 'Error getting the recipes for the user')
    }

    return response.json()
  }

  /**
   * Makes a POST request to the API to create a recipe
   * @param recipe The recipe to create
   * @returns The API response
   * @author Oriol Plazas
   * @since 18/08/2026
   */
  public async postRecipe(recipe: RecipeCreationPayload): Promise<Recipe> {
    const token = localStorage.getItem('token')
    if (!token) {
      throw new Error('No token available to get the user')
    }
    const url: string = `${this.BASE_URL}/recipes`
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(recipe),
    })

    if (!response.ok) {
      const errorText = await response.text()
      throw new Error(errorText || 'Error posting the recipes for the user')
    }

    return response.json()
  }
}
