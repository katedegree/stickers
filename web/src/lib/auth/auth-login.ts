import { fetchApi } from "@/utils/fetch-api";

export interface AuthLoginRequest {
  email: string;
  password: string;
}

export interface AuthLoginResponse {
  token: string;
}

export function authLogin(req: AuthLoginRequest): Promise<AuthLoginResponse> {
  return fetchApi("POST", "/auth/login", req);
}
