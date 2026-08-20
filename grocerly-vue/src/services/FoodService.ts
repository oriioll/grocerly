/// <reference types="vite/client" />

import type { Food } from '../types/food'

export class FoodService {
  private readonly BASE_URL = import.meta.env.VITE_API_BASE_URL?.replace(/\/$/, '') || ''

  /**
   * Makes a GET request to the API to get all the foods
   * @returns The API response
   * @author Oriol Plazas
   * @since 20/08/2026
   */
  public async getFoods(): Promise<Food[]> {
    const url: string = `${this.BASE_URL}/food`
    const response = await fetch(url, {
      method: 'GET',
      headers: {
        Accept: 'application/json',
      },
    })

    if (!response.ok) {
      const errorText = await response.text()
      throw new Error(errorText || 'Error getting the foods')
    }

    return response.json()
  }
}
