<?php
namespace Controller;

trait ControllerDataTrait {
    /**
     * @return array
     */
    public function getViewData(): array {
        return $this->view->data;
    }

    /**
     * @param array $data
     *
     * @return ControllerDataTrait
     */
    public function setViewData(array $data): self {
        $this->view->data === null and $this->view->data = [];
        $this->view->data = \array_merge_recursive($this->view->data, $data);

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     *
     * @return array
     */
    public function setViewSingleData(string $key, $value): array {
        $this->view->data[$key] = $value;

        return $this->view->data;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasViewData(string $key): bool {
        return \array_key_exists($key, $this->view->data);
    }

    /**
     * @return array
     */
    public function getGlobalViewData(): array {
        return $this->view->global;
    }

    /**
     * @param array $data
     *
     * @return ControllerDataTrait
     */
    public function setGlobalViewData(array $data): self {
        $this->view->global === null and $this->view->global = [];
        $this->view->global = \array_merge_recursive($this->view->global, $data);

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     *
     * @return array
     */
    public function setGlobalSingleViewData(string $key, $value): array {
        $this->view->global[$key] = $value;

        return $this->view->global;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasGlobalViewData(string $key): bool {
        return \array_key_exists($key, $this->view->global);
    }
}