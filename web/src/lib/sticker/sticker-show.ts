import { fetchApi } from "@/utils/fetch-api";

export type Sticker = {
  id: number;
  url: string;
  user: {
    id: number;
    name: string;
    iconUrl: string | null;
  };
  histories: {
    id: number;
    name: string;
    iconUrl: string | null;
  }[];
};

export interface StickerShowResponse {
  sticker: Sticker;
}

export function stickerShow(stickerId: number): Promise<StickerShowResponse> {
  return fetchApi("GET", `/stickers/${stickerId}`);
}
