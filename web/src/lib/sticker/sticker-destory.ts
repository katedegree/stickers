import { fetchApi } from "@/utils/fetch-api";

export function stickerDestroy(stickerId: number) {
  return fetchApi("DELETE", `/stickers/${stickerId}`);
}
