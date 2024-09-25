<?php

namespace classes;

class HealthAnalyzer
{
    private string $gender;
    private int $age;
    private int $height;
    private int $weight;

    private array $disorders;
    private array $examinations;

    /**
     * @param string $gender
     * @param int $age
     * @param int $height
     * @param int $weight
     * @param array $disorders
     */
    public function __construct(string $gender, int $age, int $height, int $weight, array $disorders)
    {
        $this->gender = $gender;
        $this->age = $age;
        $this->height = $height;
        $this->weight = $weight;
        $this->disorders = $disorders;
        $this->setExaminations();
    }

    private function ageGroup():string {
        /*
        <18  -> 18
        18-30 -> 30
        30-50 -> 50
        >50   -> 50+
        */

        $age = $this->getAge();

        if ($age < 18) {
            return '18';
        } elseif ($age <= 30) {
            return '30';
        } elseif ($age <= 50) {
            return '50';
        } else {
            return '50+';
        }
    }

    private function BMI(int $weight, int $height): int{
        $heightInMeters = $height / 100; // cm-ből méterbe váltás

        $bmi = $weight / ($heightInMeters * $heightInMeters);

        // egész számmá alakítjuk
        return (int) round($bmi);
    }

    private function isOverweight():bool{
        if($this->BMI($this->getWeight(),$this->getHeight())>=25){
            return true;
        }else{
            return false;
        }
    }

    public function recommendExamination():array {
        $recommendedExaminations = [];

        foreach ($this->examinations as $examination) {
            // szűrés nemek szerint
            if (
                ($this->gender === 'ferfi' && in_array('male', $examination['gender'])) ||
                ($this->gender === 'no' && in_array('female', $examination['gender']))) {

                //hozzáadás korcsoport szerint
                if(in_array($this->ageGroup(),$examination['age'])){
                    if (!in_array($examination['id'], $recommendedExaminations)) {
                        $recommendedExaminations[] = $examination['id'];
                    }
                }

                //hozzáadás túlsúly szerint
                if($this->isOverweight() && in_array('ow',$examination['riskFactors'])){
                    if (!in_array($examination['id'], $recommendedExaminations)) {
                        $recommendedExaminations[] = $examination['id'];
                    }
                }

                //hozzáadás egyéb rizikófaktorok szerint

                foreach ($this->disorders as $disorder) {
                    if (in_array($disorder, $examination['riskFactors'])) {
                        if (!in_array($examination['id'], $recommendedExaminations)) {
                            $recommendedExaminations[] = $examination['id'];
                        }
                    }
                }
            }
        }

        return $recommendedExaminations;
    }


    public  function getExaminations(): array
    {
        return $this->examinations;
    }
    public  function setExaminations():void
    {
        $json = file_get_contents(__DIR__ .'/../data/szurovizsgalatok.json');
        $data = json_decode($json, true);
        $this->examinations = $data;
    }
    public  function getDisorders(): array
    {
        return $this->disorders;
    }
    public  function setDisorders(array $disorders):void
    {
        $this->disorders = $disorders;
    }

    public  function getGender(): string
    {
        return $this->gender;
    }
    public  function setGender(string $gender):void
    {
        $this->gender = $gender;
    }
    public  function getAge(): int
    {
        return $this->age;
    }
    public  function setAge(int $age):void
    {
        $this->age = $age;
    }
    public  function getHeight(): int
    {
        return $this->height;
    }
    public  function setHeight(int $height):void
    {
        $this->height = $height;
    }
    public  function getWeight(): int
    {
        return $this->weight;
    }
    public  function setWeight(int $weight):void
    {
        $this->weight = $weight;
    }



}