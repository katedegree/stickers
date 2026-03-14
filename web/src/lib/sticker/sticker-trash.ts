import { fetchApi } from "@/utils/fetch-api";

export function stickerTrash(stickerId: number) {
  return fetchApi("POST", `/stickers/${stickerId}/trash`);
}
