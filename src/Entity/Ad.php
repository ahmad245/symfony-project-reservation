<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *     fields={"title", "slug"},
 *     errorPath="slug",
 *     message="This title is already in use on that slug."
 * )
 */
class Ad
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your title  must be at least {{ limit }} characters long",
     *      maxMessage = "Your title name cannot be longer than {{ limit }} characters"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      min = 2,
     *      max = 50000,
     *      minMessage = "Your description  must be at least {{ limit }} characters long",
     *      maxMessage = "Your description name cannot be longer than {{ limit }} characters"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     *  @Assert\Length(
     *      min = 2,
     *      max = 50000,
     *      minMessage = "Your content  must be at least {{ limit }} characters long",
     *      maxMessage = "Your content name cannot be longer than {{ limit }} characters"
     * )
     */
    private $content;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCreate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $publish;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\PositiveOrZero
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="date",nullable=true)
    
     */
    private $startDate;
    /**
     * @ORM\Column(type="date",nullable=true)
   
     */
    private $endDate;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $solid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;
    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     */
    private $coverImage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="ad", orphanRemoval=true)
     * @Assert\Valid()
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="ads")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="ad")
     */
    private $bookings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="ad",orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AdLike", mappedBy="ad")
     */
    private $likes;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function  initSlug()
    {
        if (empty($this->slug)) {
            $slugFy = new Slugify();
            $this->slug = $slugFy->slugify($this->title);
        }
    }
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function initDate()
    {
        $this->dateCreate = new \DateTime();
    }
   
   


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->dateCreate;
    }

    public function setDateCreate(\DateTimeInterface $dateCreate): self
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    public function getPublish(): ?bool
    {
        return $this->publish;
    }

    public function setPublish(bool $publish): self
    {
        $this->publish = $publish;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $StartDate): self
    {
        $this->startDate = $StartDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }
    /**
     * Get the value of solid
     */
    public function getSolid(): ?int
    {
        return $this->solid;
    }
    public function setSolid($solid): self
    {
        $this->solid = $solid;
        return $this;
    }


    /**
     * Get the value of location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set the value of location
     *
     * @return  self
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }



    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setAd($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getAd() === $this) {
                $image->setAd(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of coverImage
     */
    public function getCoverImage()
    {
        return $this->coverImage;
    }

    /**
     * Set the value of coverImage
     *
     * @return  self
     */
    public function setCoverImage($coverImage)
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setAd($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getAd() === $this) {
                $booking->setAd(null);
            }
        }

        return $this;
    }
  

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $ye): self
    {
        if (!$this->comments->contains($ye)) {
            $this->comments[] = $ye;
            $ye->setAd($this);
        }

        return $this;
    }

    public function removeComment(Comment $ye): self
    {
        if ($this->comments->contains($ye)) {
            $this->comments->removeElement($ye);
            // set the owning side to null (unless already changed)
            if ($ye->getAd() === $this) {
                $ye->setAd(null);
            }
        }

        return $this;
    }
    public function getNotAvailableDays()
    {
        $availabel = [];
        foreach ($this->bookings as $key) {
            $result = range($key->getStartDate()->getTimestamp(), $key->getEndDate()->getTimestamp(), 24 * 60 * 60);

            $day = array_map(function ($el) {
                return new \DateTime(date('Y-m-d', $el));
            }, $result);
            
            $availabel = array_merge($availabel, $day);
            
           
        }
       
        return $availabel;
       
    }
    public function getAvgRating(){
       $sum= array_reduce( $this->comments->toArray(),function($total,$comment){
            return  $total+$comment->getRating();
        },0);
        if( count( $this->comments) > 0)  return $sum / count( $this->comments);
        return 0;
    }

    public function getCommentForUser(User $user){
        foreach($this->comments as $comment){
            if($comment->getUser()=== $user) return $comment;
        }
        return null;
    }

    /**
     * @return Collection|AdLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(AdLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setAd($this);
        }

        return $this;
    }

    public function removeLike(AdLike $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getAd() === $this) {
                $like->setAd(null);
            }
        }

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param User $user
     * @return boolean
     */
    public function isLikedByUser(User $user):bool{
        foreach($this->likes as $like){
           if($like->getUser() ==$user) return true;
        }
        return false;
        
    }
}
