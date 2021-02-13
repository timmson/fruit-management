<?php


namespace ru\timmson\FruitMamangement;


class HTTPSession implements Session
{

    private array $session;

    /**
     * HTTPSession constructor.
     * @param array $session
     */
    public function __construct(array $session)
    {
        $this->session = $session;
    }


    /**
     * @inheritDoc
     */
    public function get(string $name)
    {
        return $this->session[$name];
    }

    /**
     * @inheritDoc
     */
    public function set(string $name, $value)
    {
        return $this->session[$name] = $value;
    }

    /**
     * @inheritDoc
     */
    public function contains(string $name): bool
    {
        return isset($this->session[$name]);
    }
}