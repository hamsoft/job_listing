<?php


namespace JobListing\Entities;


use Carbon\Carbon;


/**
 * JobListing\Entities\JobPosition
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $company_id
 * @property int $manager_id
 * @property string $name
 * @property string|null $description
 * @property Carbon $deadline
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\JobListing\Entities\Candidate[] $candidates
 * @property-read \JobListing\Entities\Company $company
 * @property-read \JobListing\Entities\User $manager
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\JobPosition whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\JobPosition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\JobPosition whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\JobPosition whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\JobPosition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\JobPosition whereManagerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\JobPosition whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\JobPosition whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\JobPosition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\JobPosition whereOpenPositions()
 */
class JobPosition extends \Eloquent
{
    public static $statuses = ['1' => 'Open', '2' => 'Done', '3' => 'Canceled'];

    protected $table = 'job_positions';

    protected $fillable = ['name', 'description', 'deadline'];


    public function candidates() {
        return $this->hasMany(Candidate::class, 'job_position_id');
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function manager() {
        return $this->belongsTo(User::class);
    }

    public function getId(): int {
        return $this->id;
    }

    public function getDeadline() {
        if ($this->attributes['deadline'] instanceof Carbon) {
            return $this->deadline;
        }
        return Carbon::parse($this->attributes['deadline']);
    }

    public function setDeadlineAttribute($date) {
        if (\is_string($date)) {
            $this->attributes['deadline'] = Carbon::parse($date);
        }
    }

    public function setManager($user) {
        $this->manager()->associate($user);
    }

    public function setCompany($company) {
        $this->company()->associate($company);
    }

    public function getCompanyId(): int {
        return $this->company_id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setStatus($status) {
        $this->status = self::$statuses[$status];
    }

    public function setStatusOpen() {
        $this->status = 1;
    }

    public function setStatusDone() {
        $this->status = 2;
    }

    public function setStatusCancel() {
        $this->status = 3;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getStatus(): int {
        return $this->status;
    }

    public function getDescription(): string {
        return $this->description ?? '';
    }

    public function isOpen() {
        return $this->status === 1;
    }

    public function getCandidates() {
        return $this->candidates;
    }

    public function scopeWhereOpenPositions($query) {
        /** @var JobPosition|\Illuminate\Database\Eloquent\Builder $query */
        $query->where('status', '=', 1);
        $query->whereDate('deadline', '>', Carbon::now());
    }

    public function getCompany(): Company {
        return $this->company;
    }


}