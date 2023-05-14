export function okAndJson(json: any): Promise<Response> {
    return Promise.resolve({
        arrayBuffer(): Promise<ArrayBuffer> {
            return Promise.resolve(undefined);
        },
        blob(): Promise<Blob> {
            return Promise.resolve(undefined);
        },
        body: undefined,
        bodyUsed: false,
        clone(): Response {
            return undefined;
        },
        formData(): Promise<FormData> {
            return Promise.resolve(undefined);
        },
        headers: undefined,
        json(): Promise<any> {
            return Promise.resolve(json);
        },
        ok: true,
        redirected: false,
        status: 200,
        statusText: "OK",
        text(): Promise<string> {
            return Promise.resolve("");
        },
        type: undefined,
        url: ""
    })
}