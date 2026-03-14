import Cookie from "js-cookie";
import { cookies } from "next/headers";

const ACCESS_TOKEN_KEY = "accessToken";

export const accessToken = {
  get: async () => {
    const cookieStore = await cookies();
    return cookieStore.get(ACCESS_TOKEN_KEY)?.value;
  },
  set: (value: string) => Cookie.set(ACCESS_TOKEN_KEY, value, { expires: 31 }),
  remove: () => Cookie.remove(ACCESS_TOKEN_KEY),
};
