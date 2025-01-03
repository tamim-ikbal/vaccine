<?php

namespace App\DTO;

use App\Abstract\DTO;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EnrollDTO extends DTO
{
    public string $name;
    public string $email;
    public string $phone;
    public string $nid;
    public DateTime $dob;
    public int $vaccineCenterId;
    public ?DateTime $scheduleAt = null;

    public static function createFromRequest(Request $request): EnrollDTO
    {
        return new self([
            'name'            => $request->input('name'),
            'email'           => $request->input('email'),
            'phone'           => $request->input('phone'),
            'nid'             => $request->input('nid'),
            'dob'             => Carbon::createFromFormat('Y-m-d', $request->input('dob')),
            'vaccineCenterId' => $request->input('vaccine_center_id'),
        ]);
    }

    public function toArray(): array
    {
        $data = [
            'name'              => $this->name,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'nid'               => $this->nid,
            'dob'               => $this->dob,
            'vaccine_center_id' => $this->vaccineCenterId,
        ];

        if ($this->scheduleAt) {
            $data['schedule_at'] = $this->scheduleAt;
        }

        return $data;
    }

}
