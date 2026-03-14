import { fetchApi } from "@/utils/fetch-api";

export interface AuthRegisterRequest {
  name: string;
  email: string;
  password: string;
}

export interface AuthRegisterResponse {
  token: string;
}

export function authRegister(req: AuthRegisterRequest): Promise<AuthRegisterResponse> {
  return fetchApi("POST", "/auth/register", req);
}
