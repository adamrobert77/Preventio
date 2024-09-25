<?php

namespace classes;

class Examination
{
    private string $id;
    private string $title;
    private string $image;
    private string $description;
    private array $gender;
    private array $age;
    private array $riskFactors;

    /**
     * @param string $title
     * @param string $image
     * @param string $description
     * @param array $gender
     * @param array $age
     * @param array $riskFactors
     */
    public function __construct(string $title, string $image, string $description, array $gender, array $age, array $riskFactors)
    {
        $this->id = uniqid();
        $this->title = $title;
        $this->image = $image;
        $this->description = $description;
        $this->gender = $gender;
        $this->age = $age;
        $this->riskFactors = $riskFactors;
    }

    /**
     * Returns an associative array representing the examination data by its ID from a JSON file.
     *
     * @param string $id The ID of the examination to retrieve
     * @param string $filePath The path to the JSON file
     * @return array|null The examination data as an associative array if found, null otherwise
     * @throws \Exception If there's an error reading the JSON file
     */
    public static function getById(string $id, string $filePath): ?array {
        try {
            $json = file_get_contents($filePath);
            $data = json_decode($json, true);

            // Find the examination with the given ID
            foreach ($data as $examination) {
                if ($examination['id'] === $id) {
                    return $examination;
                }
            }

            // If examination with given ID is not found
            return null;
        } catch (\Exception $e) {
            throw new \Exception('Error reading JSON file: ' . $e->getMessage());
        }
    }


    /**
     * @throws \Exception
     */
    public function saveToJSON(Examination $examination, string $filePath) :bool{
        try {
            if (!is_writable($filePath)) {
                throw new \Exception("A fájl nem létezik vagy nem írható.");
            }

            $json = file_get_contents($filePath);
            $data = json_decode($json, true);

            $data[] = [
                'id' => $examination->getId(),
                'title' => $examination->getTitle(),
                'description' => $examination->getDescription(),
                'image' => $examination->getImage(),
                'gender' => $examination->getGender(),
                'age' => $examination->getAge(),
                'riskFactors' => $examination->getRiskFactors()
            ];

            $result = file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));

            return $result !== false;

        }catch(\Exception $e){
            throw new \Exception('Hiba a vizsgálat hozzáadása során: ' . $e->getMessage());
        }
    }
    public  function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    public  function getGender(): array
    {
        return $this->gender;
    }
    public  function setGender(array $gender):void
    {
        $this->gender = $gender;
    }
    public  function getAge(): array
    {
        return $this->age;
    }
    public  function setAge(array $age):void
    {
        $this->age = $age;
    }
    public  function getRiskFactors(): array
    {
        return $this->riskFactors;
    }
    public  function setRiskFactors(array $riskFactors):void
    {
        $this->riskFactors = $riskFactors;
    }




}