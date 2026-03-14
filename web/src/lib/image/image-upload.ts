import { accessToken } from "@/utils/access-token";

export interface ImageStoreRequest {
  file: File;
  directory: string;
}

export function mediaStore(req: ImageStoreRequest) {
  const url = `${process.env.NEXT_PUBLIC_API_URL}/images/upload`;
  const token = accessToken.get();

  const form = new FormData();
  form.append("file", req.file);
  form.append("directory", req.directory);
  return fetch(url, {
    method: "POST",
    headers: {
      Authorization: `Bearer ${token}`,
    },
    body: form,
  }).then((res) => res.json());
}
