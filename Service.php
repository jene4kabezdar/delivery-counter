<?php

    class ServiceManager {
        /** id сервиса "Быстрая доставка" */
        const SERVICE_ID_FAST_DELIVERY = 1;
        /** id сервиса "Медленная доставка" */
        const SERVICE_ID_SLOW_DELIVERY = 2;

        /** базовая стоимость сервиса медленной доставки */
        const BASE_PRICE_SLOW_SERVICE = 150;

        public string $source;
        public string $target;
        public float $weight;

        public function __construct(string $source,  string $target, float $weight) {
            $this->source = $source;
            $this->target = $target;
            $this->weight = $weight;
        }

        /**
         * Метод проверяет полученные данные
         */
        private function _validate(): string {
            if (!strlen($this->source)) {
                return 'Не указано откуда везем';
            }

            if (!strlen($this->target)) {
                return 'Не указано куда везем';
            }

            if (!$this->weight) {
                return 'Не указан вес';
            }

            return '';
        }

        /**
         * Метод считает дату и время доставки для быстрой службы
         * Стоимость = длина строки "откуда" * вес
         * Время доставки = длина второй строки в днях
         */
        private function _getForFast(): array {
            $res = ['price' => 0., 'date' => '', 'error' => ''];
            $err = $this->_validate();

            if (strlen($err) > 0) {
                $res['error'] = $err;
                return $res;
            }

            $res['price'] = strlen($this->source) * $this->weight;

            $deliveryDays = strlen($this->target);
            if ((int) date('H') >= 18) {
                $deliveryDays++;
            }

            $res['date'] = date('Y-m-d', strtotime('+' . $deliveryDays . ' day'));

            return $res;
        }

        /**
         * Метод считает дату и время доставки для медленной службы
         * Коэффициент = длина строки "откуда" / вес
         * Время доставки = длина второй строки в днях
         */
        private function _getForSlow(): array {
            $res = ['coefficient' => 1., 'date' => '', 'error' => ''];
            $err = $this->_validate();

            if (strlen($err) > 0) {
                $res['error'] = $err;
                return $res;
            }

            $res['coefficient'] = strlen($this->source) / $this->weight;
            $res['date'] = date('Y-m-d', strtotime('+' . strlen($this->target) . ' day'));

            return $res;
        }

        /**
         * Метод собирает данные для всех служб
         */
        public function getForAll(): string {
            $res = [];
            $fastData = $this->_getForFast();
            if ($fastData['error']) {
                return json_encode($fastData) ?: '';
            }
            $res[] = $fastData;

            $slowData = $this->_getForSlow();
            $slowData['price'] = $slowData['coefficient'] * self::BASE_PRICE_SLOW_SERVICE;
            unset($slowData['coefficient']);
            $res[] = $slowData;

            return json_encode($res) ?: '';
        }

        /**
         * Метод возвращает данные о службе в зависимости от её id
         */
        public function getByServiceId(int $serviceId): string {
            switch ($serviceId) {
                case self::SERVICE_ID_FAST_DELIVERY:
                    return json_encode($this->_getForFast()) ?: '';
                case self::SERVICE_ID_SLOW_DELIVERY:
                    $slowData = $this->_getForSlow();
                    $slowData['price'] = $slowData['coefficient'] * self::BASE_PRICE_SLOW_SERVICE;
                    unset($slowData['coefficient']);
                    return json_encode($slowData) ?: '';
                default:
                    return $this->getForAll();
            }
        }
    }
