import { fetchApi } from "@/utils/fetch-api";

export interface StickerStoreRequest {
  imageId: number;
}

export function stickerStore(req: StickerStoreRequest) {
  return fetchApi("POST", "/stickers", req);
}
