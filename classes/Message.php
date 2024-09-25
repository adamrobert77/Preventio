<?php

namespace classes;

use Exception;

class Message
{
    private string $id;
    private array $to;
    private string $from;
    private string $text;
    private string $date;

    /**
     * @param array $to
     * @param string $from
     * @param string $text
     * @param string $date
     */
    public function __construct(array $to, string $from, string $text, string $date)
    {
        $this->id = uniqid();
        $this->to = $to;
        $this->from = $from;
        $this->text = $text;
        $this->date = $date;
    }

    /**
     * @throws Exception
     */
    public function sendMessage(Message $message, string $filePath):bool {
        try {
            if (!is_writable($filePath)) {
                throw new Exception("A fájl nem létezik vagy nem írható.");
            }

            $json = file_get_contents($filePath);
            $data = json_decode($json, true);

            $data[] = [
                'id' => $message->getId(),
                'to' => $message->getTo(),
                'from' => $message->getFrom(),
                'text' => $message->getText(),
                'date' => $message->getDate(),

            ];

            $result = file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));

            return $result !== false;

        }catch(Exception $e){
            throw new Exception('Hiba az üzenet küldése során: ' . $e->getMessage());
        }
    }
public  function getId(): string
{
    return $this->id;
}
public  function getTo(): array
{
    return $this->to;
}
public  function getFrom(): string
{
    return $this->from;
}
public  function getText(): string
{
    return $this->text;
}
public  function getDate(): string
{
    return $this->date;
}




}