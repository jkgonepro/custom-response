<?php
/**
 *
 */

namespace App\Utilities;

use Illuminate\Support\Arr;

/**
 * Class CustomResponse
 * @package App\Utilities
 *
 * @property string|null $status
 * @property string|null $message
 * @property int|null    $code
 * @property string      $statusKey
 * @property string      $messageKey
 * @property string      $codeKey
 * @property array       $extraElements
 */
class CustomResponse
{
    const DEFAULT_STATUS_KEY  = 'status';
    const DEFAULT_MESSAGE_KEY = 'message';
    const DEFAULT_CODE_KEY    = 'code';

    const NO_STATUS      = 'none';
    const STATUS_ERROR   = 'error';
    const STATUS_WARNING = 'warning';
    const STATUS_INFO    = 'info';
    const STATUS_SUCCESS = 'success';

    /**
     * @var string
     */
    private $statusKey;
    /**
     * @var string
     */
    private $messageKey;
    /**
     * @var string
     */
    private $codeKey;
    /**
     * @var string|null
     */
    private $status;
    /**
     * @var string|null
     */
    private $message;
    /**
     * @var string|null
     */
    private $code;

    /**
     * @var array $extraElements
     */
    private $extraElements = [];

    /**
     * CustomResponse constructor.
     */
    public function __construct()
    {
        $this->statusKey  = self::DEFAULT_STATUS_KEY;
        $this->messageKey = self::DEFAULT_MESSAGE_KEY;
        $this->codeKey    = self::DEFAULT_CODE_KEY;

        $this->status  = self::NO_STATUS;
        $this->message = __('message.none');
        $this->code    = null;

        $this->extraElements = [];
    }

    /**
     * @return string
     */
    public function getStatusKey(): string
    {
        return $this->statusKey;
    }

    /**
     * @param string $statusKey
     * @return CustomResponse
     */
    public function setStatusKey(string $statusKey): self
    {
        if(strlen($statusKey)) $this->statusKey = $statusKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessageKey(): string
    {
        return $this->messageKey;
    }

    /**
     * @param string $messageKey
     * @return CustomResponse
     */
    public function setMessageKey(string $messageKey): self
    {
        if(strlen($messageKey)) $this->messageKey = $messageKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeKey(): string
    {
        return $this->codeKey;
    }

    /**
     * @param string $codeKey
     * @return CustomResponse
     */
    public function setCodeKey(string $codeKey): self
    {
        if(strlen($codeKey)) $this->codeKey = $codeKey;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     * @return CustomResponse
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return CustomResponse
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param string|null $additionalMessage
     * @return CustomResponse
     */
    public function attachMessage(?string $additionalMessage): self
    {
        if(!empty($additionalMessage)){
            $this->message .= ". " . $additionalMessage;
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return CustomResponse
     */
    public function setCode(?string $code): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return int
     */
    public function getIntegerCode()
    {
        return (int)$this->getCode();
    }

    /**
     * @return CustomResponse
     */
    public function setStatusError(): self
    {
        $this->status = self::STATUS_ERROR;
        return $this;
    }

    /**
     * @return CustomResponse
     */
    public function setStatusWarning(): self
    {
        $this->status = self::STATUS_WARNING;
        return $this;
    }

    /**
     * @return CustomResponse
     */
    public function setStatusInfo(): self
    {
        $this->status = self::STATUS_INFO;
        return $this;
    }

    /**
     * @return CustomResponse
     */
    public function setStatusSuccess(): self
    {
        $this->status = self::STATUS_SUCCESS;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return CustomResponse
     */
    public function setExtraElement($key, $value = null): self
    {
        if($value !== null){
            $this->extraElements[$key] = $value;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function generateArrayResponse()
    {
        $responseArray = [
            $this->statusKey  => $this->status,
            $this->messageKey => $this->message,
            $this->codeKey    => $this->code,
        ];

        if(!empty($this->extraElements)){
            foreach($this->extraElements as $key => $value){
                Arr::set($responseArray, $key, $value);
            }
        }

        return $responseArray;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateJsonResponse()
    {
        return response()->json($this->generateArrayResponse());
    }

}
