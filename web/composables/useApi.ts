export const useApi = () => {
  const config = useRuntimeConfig()
  const baseURL = config.public.apiBase

  const get = <T>(path: string): Promise<T> =>
    $fetch<T>(`${baseURL}${path}`)

  const post = <T>(path: string, body: unknown): Promise<T> =>
    $fetch<T>(`${baseURL}${path}`, { method: 'POST', body })

  return { get, post }
}
