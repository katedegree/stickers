import { accessToken } from "./access-token";

type apiMethod = "GET" | "POST" | "PUT" | "PATCH" | "DELETE";

export function fetchApi(method: apiMethod, path: string, req?: any) {
  let url = `${process.env.NEXT_PUBLIC_API_URL}${path}`;
  const token = accessToken.get();
  const options: RequestInit = {
    method,
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    },
    body: JSON.stringify(req),
    ...(typeof window === "undefined" && { cache: "no-store" }),
  };

  if (method === "GET" || method === "DELETE") {
    options.body = undefined;
    const filteredReq = Object.entries(req || {}).reduce(
      (acc, [key, value]) => {
        if (
          value !== null &&
          value !== undefined &&
          !(Array.isArray(value) && value.length === 0)
        ) {
          acc[key] = value;
        }
        return acc;
      },
      {} as Record<string, any>,
    );
    const query = new URLSearchParams();
    Object.entries(filteredReq).forEach(([key, value]) => {
      if (Array.isArray(value)) {
        value.forEach((v) => query.append(key, String(v)));
      } else {
        query.append(key, String(value));
      }
    });

    const queryString = query.toString();
    if (queryString) url += `?${queryString}`;
  }

  return fetch(url, options).then((res) => res.json());
}
