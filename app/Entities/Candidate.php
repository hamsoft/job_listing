<?php


namespace JobListing\Entities;


use Illuminate\Database\Eloquent\Model;

/**
 * JobListing\Entities\Candidate
 *
 * @property-read \JobListing\Entities\JobPosition $jobPosition
 * @mixin \Eloquent
 * @property int $id
 * @property int $job_position_id
 * @property bool $accepted
 * @property string $name
 * @property string $email
 * @property string $phone_number
 * @property string $cover_letter
 * @property string|null $cv
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\Candidate whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\Candidate whereCoverLetter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\Candidate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\Candidate whereCv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\Candidate whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\Candidate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\Candidate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\Candidate wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\Candidate whereUpdatedAt($value)
 */
class Candidate extends Model
{

    protected $table = 'candidates';
    protected $fillable = ['name', 'email', 'cover_letter', 'phone_number'];

    public function jobPosition() {
        return $this->belongsTo(JobPosition::class);
    }

    public function isAccepted() {
        return $this->accepted;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPhoneNumber(): string {
        return $this->phone_number;
    }

    public function getCoverLetter(): string {
        return $this->cover_letter;
    }

    public function getId(): int {
        return $this->id;
    }

    public function gerJobPositionId(): int {
        return $this->job_position_id;
    }

    public function acceptToPosition() {
        $this->accepted = true;
    }

    public function getPosition() {
        return $this->jobPosition;
    }

    public function setPosition(JobPosition $position) {
        $this->jobPosition()->associate($position);
    }

    public function hasCv(): bool {
        return !empty($this->cv);
    }

    public function setCv($cv) {
        $this->cv = $cv;
    }

    public function getCv() {
        return $this->cv;
    }

}