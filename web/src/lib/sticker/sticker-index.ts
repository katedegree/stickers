import { fetchApi } from "@/utils/fetch-api";

export type Stickers = {
  id: number;
  url: string;
}[];

export interface StickerIndexRequest {
  offset?: number;
  limit?: number;
}

export interface StickerIndexResponse {
  stickers: Stickers;
  lastPage: number;
}

export function stickerIndex(req: StickerIndexRequest) {
  return fetchApi("GET", "/stickers", req);
}
