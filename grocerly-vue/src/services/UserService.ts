/// <reference types="vite/client" />

import type { User } from '../types/user'
import { useCookies } from 'vue3-cookies'

export class UserService {
  private readonly cookies = useCookies().cookies
  private readonly BASE_URL = import.meta.env.VITE_API_BASE_URL?.replace(/\/$/, '') || ''

  /**
   * Makes a POST request to the API to create the user, generating its token.
   * @param username The username of the new user
   * @returns The API response
   * @author Oriol Plazas
   * @since 11/08/2026
   */
  public async createUser(username: string) {
    const userBody: User = {
      name: username,
      token: crypto.randomUUID(),
    }
    const url: string = this.BASE_URL + '/auth/register'
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
      body: JSON.stringify(userBody),
    })

    if (!response.ok) {
      const errorText = await response.text()
      throw new Error(errorText || 'Error creating user - try again later')
    }
    //Before returning the result, set the token cookie
    this.cookies.set('token', userBody.token, '365d')
    return response.json()
  }

  /**
   * Makes a GET request to the API to get the current user based on the token in the cookie.
   * @returns The API response
   * @author Oriol Plazas
   * @since 11/08/2026
   */
  public async getMe(): Promise<User> {
    const token = this.cookies.get('token')
    if (!token) {
      throw new Error('No token available to get the user')
    }
    const url: string = '${this.BASE_URL} + /auth/me'
    const response = await fetch(url, {
      method: 'GET',
    })

    if (!response.ok) {
      const errorText = await response.text()
      throw new Error(errorText || 'Error getting user')
    }

    return response.json()
  }
}
