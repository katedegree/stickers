import { fetchApi } from "@/utils/fetch-api";

export interface MeUpdateRequest {
  name?: string;
  email?: string;
  password?: string;
  iconImageId?: number;
}

export function meUpdate(req: MeUpdateRequest) {
  return fetchApi("PATCH", "/me", req);
}
