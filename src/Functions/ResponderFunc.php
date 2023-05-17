<?php

use Cramtu\Responder\Facades\ResponderFacade;
use Cramtu\Responder\Responder;
use Illuminate\Http\JsonResponse;

if (!function_exists('return_response')) {
    /**
     * @throws Throwable
     */
    function return_response(): JsonResponse
    {
        $responseData = ResponderFacade::getErrorStack();

        #error stack boş ise bir şey dönemeyiz hata döndürelim
        throw_if(empty($responseData), "RuntimeException", massage: "error stack boş");

        if (!isset($responseData[Responder::RESPONDER_DATA]))
            $responseData[Responder::RESPONDER_DATA] = [];

        #gelen mesajın dil dosyalarında bir çeviri varsa ekleyelim yok ise direk key döndürücez
        $responseData[Responder::RESPONDER_MESSAGE] = __($responseData[Responder::RESPONDER_MESSAGE]);

        return response()->json(data: $responseData);

    }
}
