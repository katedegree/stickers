import { fetchApi } from "@/utils/fetch-api";

export type Me = {
  id: number;
  name: string;
  email: string;
  iconUrl: string;
  stickers: {
    id: number;
    url: string;
  }[];
}

export interface MeIndexResponse {
  me: Me;
};

export function meIndex(): Promise<MeIndexResponse> {
  return fetchApi("GET", "/me");
}
