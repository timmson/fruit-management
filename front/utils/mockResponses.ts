export function okAndJson(json: any): Promise<Response> {
    const mock: Response = {
        arrayBuffer(): Promise<ArrayBuffer> {
            return Promise.resolve(new ArrayBuffer(0));
        },
        blob(): Promise<Blob> {
            return Promise.resolve(new Blob());
        },
        bytes(): Promise<Uint8Array> {
            return Promise.resolve(new Uint8Array(0));
        },
        body: null,
        bodyUsed: false,
        clone(): Response {
            return mock;
        },
        formData(): Promise<FormData> {
            return Promise.resolve(new FormData());
        },
        headers: new Headers(),
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
        type: "basic",
        url: ""
    } as Response;
    return Promise.resolve(mock);
}