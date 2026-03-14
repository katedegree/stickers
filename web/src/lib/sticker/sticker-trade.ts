import { fetchApi } from "@/utils/fetch-api";

export interface StickerTradeResponse {
  stickerId: number;
}

export function stickerTrade(stickerId: number): Promise<StickerTradeResponse> {
  return fetchApi("POST", `/stickers/${stickerId}/trade`);
}
