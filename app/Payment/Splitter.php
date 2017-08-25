<?php

namespace App\Payment;

use App\{Member, Bill, Transaction};

class Splitter
{
    private $debtsPerMember;
    private $splittedValue;

    const MAX_DIFFERENCE = 0.05;

    public function __construct(array $paymentIds, array $memberIds, $groupId)
    {
        $this->validateMembers($memberIds, $groupId);
        $payments = $this->validateAndGetPayments($paymentIds, $groupId);

        $this->debtsPerMember = $this->getDebtsPerMember($payments, $memberIds);

        return $this;
    }

    /**
     * Split a bill by creating multiple transactions
     *
     * @param Bill $bill
     * @return array
     */
    public function split(Bill $bill)
    {
        $transactions = [];
        foreach ($this->debtsPerMember as $creditorId => $credit) {
            if ($this->debtsPerMember[$creditorId] <= 0) {
                continue;
            }
            foreach ($this->debtsPerMember as $debtorId => $debt) {
                if ($this->shouldUpdateNextCreditor($creditorId)) {
                    continue 2;
                } else if($this->debtsPerMember[$debtorId] >= 0) {
                    continue;
                }
                $value = $this->getValueToSubtract($this->debtsPerMember[$creditorId], $debt);
                $this->updateDebts($value, $creditorId, $debtorId);

                $transactions[] = [
                    'creditor' => $creditorId,
                    'debtor'   => $debtorId,
                    'value'    => $value,
                    'bill_id'  => $bill->id,
                ];
            }
        }
        return $transactions;
    }

    /**
     * Returns the splitted value, by choosing the v
     *
     * @return void
     */
    public function getSplittedValue()
    {
        return $this->averageValue;
    }

    /**
     * Returns true if credit is small enough to start checking next members 
     *
     * @param int $creditorId
     * @return boolean
     */
    private function shouldUpdateNextCreditor($creditorId)
    {
        return abs($this->debtsPerMember[$creditorId]) <= self::MAX_DIFFERENCE;
    }

    /**
     * Update debts of debtsPerMember from the calculated value
     *
     * @param int $subtractValue
     * @param int $creditorId
     * @param int $debtorId
     * @return void
     */
    private function updateDebts($value, $creditorId, $debtorId)
    {
        $this->debtsPerMember[$creditorId] -= $value;
        $this->debtsPerMember[$debtorId] += $value;
    }

    /**
     * Validate if all payments belongs to group and throws exception if not valid
     *
     * @param int[] $paymentIds
     * @param int $groupId
     * @return App\Payment\Payment[]
     */
    private function validateAndGetPayments($paymentIds, $groupId)
    {
        $payments = Payment::find($paymentIds);
        foreach($payments as $payment) {
            if ($payment->group()->id != $groupId) {
                throw new WrongGroupException("Some of the payments does not belongs to the group");
            }
        }
        return $payments;
    }

    /**
     * Validate if all members belongs to group and throws exception if not valid
     *
     * @param int[] $memberIds
     * @param int $groupId
     */
    private function validateMembers($memberIds, $groupId)
    {
        $members = Member::find($memberIds);
        foreach($members as $member) {
            if ($member->group_id != $groupId) {
                throw new WrongGroupException("Some of the members does not belongs to the group");
            }
        }
    }

    /**
     * Returns an array where the key is the memberId and the value is how much the member should pay.
     * Positive values means he should receive, while negative values means he should pay.
     *
     * @param App\Payment\Payment[] $payments
     * @param int[] $memberIds
     * @return array
     */   
    private function getDebtsPerMember($payments, $memberIds) : array
    {
        $valuesPerMember = array_fill_keys($memberIds, 0);

        foreach ($payments as $payment) {
            $valuesPerMember[$payment->member_id] += $payment->value;
        }
        $this->averageValue = array_sum($valuesPerMember) / count ($memberIds);

        return array_map(function($valuePerMember) {
            return $valuePerMember - $this->averageValue;
        }, $valuesPerMember);
    }

    /**
     * Returns how much should be removed from the credit
     *
     * @param int $credit
     * @param int $debt
     * @return int
     */
    private function getValueToSubtract($credit, $debt) : int
    {
        return min($credit, abs($debt));
    }
}
