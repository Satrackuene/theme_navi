<?php
class SchemaJsonValidator
{
    private $schema;

    public function __construct($schema)
    {
        $this->schema = $schema;
    }

    public function validate($data)
    {
        // Decodificar el esquema JSON y los datos JSON
        $schemaArray = json_decode($this->schema, true);
        $dataArray = json_decode($data, true);

        // Validar los datos contra el esquema
        return $this->validateSchema($schemaArray, $dataArray);
    }

    public function validateObject($data)
    {
        // Decodificar el esquema JSON
        $schemaArray = json_decode($this->schema, true);

        // Validar los datos contra el esquema
        return $this->validateSchema($schemaArray, $data);
    }

    private function validateSchema($schema, $data)
    {
        $dataf = (array) $data;
        // Validar el tipo de dato
        foreach ($dataf as $property => $value) {
            echo gettype($value) . "<br>";

            if (!isset($schema['properties'][$property])) {
                echo "no esta la propiedad en el esquema";
                return false;
            } else {
                if (gettype($value) !== $schema['properties'][$property]['type']) {

                    echo "la propiedad es diferente tipo";
                    return false;
                }

                if (gettype($value) === "object") {
                    if (!$this->validateSchema($value, $schema['properties'][$property])) {
                        return false;
                    }
                }
            }
        }

        return $this->validateRequired($schema, $data);
    }

    private function validateRequired($schema, $data)
    {
        foreach ($schema['required'] as $property) {
            if (!isset($data[$property]) || empty($data[$property])) {
                echo "este campo es requerido y no esta";
                return false;
            }
        }

        return true;
    }
}
