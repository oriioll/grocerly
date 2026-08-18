/// <reference types="vite/client" />

import type { ShoppingList } from '@/types/shoppingList'

export class ListService {
  private readonly BASE_URL = import.meta.env.VITE_API_BASE_URL?.replace(/\/$/, '') || ''

  /**
   * Makes a GET request to the API to get all the lists from the user
   * @returns The API response
   * @author Oriol Plazas
   * @since 15/08/2026
   */
  public async getMyLists(): Promise<ShoppingList[]> {
    const token = localStorage.getItem('token')
    if (!token) {
      throw new Error('No token available to get the user')
    }
    const url: string = `${this.BASE_URL}/shopping-lists`
    const response = await fetch(url, {
      method: 'GET',
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
      },
    })

    if (!response.ok) {
      const errorText = await response.text()
      throw new Error(errorText || 'Error getting the lists for the user')
    }

    return response.json()
  }

  /**
   * Makes a POST request to the API to create a list
   * @returns The API response
   * @author Oriol Plazas
   * @since 18/08/2026
   */
  public async postRecipe(): Promise<ShoppingList> {
    const token = localStorage.getItem('token')
    if (!token) {
      throw new Error('No token available to get the user')
    }
    const url: string = `${this.BASE_URL}/shopping-lists`
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
      },
    })

    if (!response.ok) {
      const errorText = await response.text()
      throw new Error(errorText || 'Error posting the shopping list for the user')
    }
    return response.json()
  }
}
