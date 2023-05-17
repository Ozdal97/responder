<?php

namespace Cramtu\Responder;

use Exception;
use Illuminate\Support\Facades\Validator;

class Responder
{

    #zorunlu keylerimiz
    public const RESPONDER_MESSAGE = "message";
    public const RESPONDER_CODE = "code";
    public const RESPONDER_DATA = "data";

    /**
     * hataların setlenecegi array
     * @var array
     */
    private array $errorStack = [];

    /**
     * eğer bir hata var ise true yok ise false olacak değer
     * @var bool
     */
    private bool $isError = false;

    public function hasError(): bool
    {
        return $this->isError;
    }

    /**
     * Bu methot classın ana fonsiyonudur
     * array halinde gelen hata keyleri kontrol edilir
     * eğer doğru keyler gelmiş ise setlenir
     * @throws Exception
     */
    public function setErrorStack(array $errors): Responder
    {
        # gelen array içerindeki keyler istedigimiz gibi kontrol edelim
        $this->checkErrors($errors);

        #artık bir hatamız var kontrol için değeri true yapalım
        $this->setIsError(true);

        # arrayi setleyelım
        $this->errorStack = $errors;

        return $this;
    }

    /**
     * bu methot aşşagıdakı belirtilen şekilde hata setlenmesi halinde throw atar.
     * 'message' => "hata " Kullanıcıya gösterilecek mesaj
     * 'code' => 52141,  hatayı tespit için hata kodu
     * 'data' => [], zorun olmayan parametre eğer gelmez ise boş array olarak döndürülür
     * @param array $errors
     * @return void
     * @throws Exception
     */
    private function checkErrors(array $errors): void
    {
        #validate için kuralları belirleyelim
        $rules = [
            self::RESPONDER_MESSAGE => 'required',
            self::RESPONDER_CODE => 'required',
        ];

        $validator = Validator::make($errors, $rules);
        #eğer bizim istedigimiz gibi gelmiyor ise trow atalım paketi kullanan düzgün kullansın :)
        if ($validator->fails()) {
            throw new Exception($validator->errors());
        }
    }

    /**
     * Bu methot daha önceden setlenen hataları temizler
     * @return $this
     */
    public function clearErrorStack(): Responder
    {
        $this->errorStack = [];
        return $this;
    }

    /**
     * Toplanmış olan tüm error responseları getirmek için kullanılır
     * @return array
     */
    public function getErrorStack(): array
    {
        return $this->errorStack;
    }

    /**
     * @param bool $isError
     */
    public function setIsError(bool $isError): void
    {
        $this->isError = $isError;
    }


}
