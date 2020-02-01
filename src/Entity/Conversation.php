<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConversationRepository")
 */
class Conversation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="conversationsStarter")
     * @ORM\JoinColumn(nullable=false)
     */
    private $starter;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="conversationsReceiver")
     * @ORM\JoinColumn(nullable=false)
     */
    private $receiver;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PrivateMessage", mappedBy="conversation", cascade={"persist"})
     */
    private $privateMessages;

    public function __construct()
    {
        $this->privateMessages = new ArrayCollection();
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

    public function getStarter(): ?User
    {
        return $this->starter;
    }

    public function setStarter(?User $starter): self
    {
        $this->starter = $starter;

        return $this;
    }

    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    public function setReceiver(?User $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * @return Collection|PrivateMessage[]
     */
    public function getPrivateMessages(): Collection
    {
        return $this->privateMessages;
    }

    public function addPrivateMessage(PrivateMessage $privateMessage): self
    {
        if (!$this->privateMessages->contains($privateMessage)) {
            $this->privateMessages[] = $privateMessage;
            $privateMessage->setConversation($this);
        }

        return $this;
    }

    public function removePrivateMessage(PrivateMessage $privateMessage): self
    {
        if ($this->privateMessages->contains($privateMessage)) {
            $this->privateMessages->removeElement($privateMessage);
            // set the owning side to null (unless already changed)
            if ($privateMessage->getConversation() === $this) {
                $privateMessage->setConversation(null);
            }
        }

        return $this;
    }
}
