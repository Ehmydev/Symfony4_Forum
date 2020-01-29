<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"login"}, message="Il y a déjà un utilisateur avec ce pseudo.")
 */
class User implements UserInterface, Serializable
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
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $about;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Rank", inversedBy="users")
     */
    private $rank;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Topic", mappedBy="user")
     */
    private $topics;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="user")
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PrivateMessage", mappedBy="author")
     */
    private $privateMessages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Conversation", mappedBy="starter")
     */
    private $conversationsStarter;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Conversation", mappedBy="receiver")
     */
    private $conversationsReceiver;

    public function __construct()
    {
        $this->rank = new ArrayCollection();
        $this->topics = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->privateMessages = new ArrayCollection();
        $this->conversationsStarter = new ArrayCollection();
        $this->conversationsReceiver = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): self
    {
        $this->about = $about;

        return $this;
    }

    /**
     * @return Collection|Rank[]
     */
    public function getRank(): Collection
    {
        return $this->rank;
    }

    public function addRank(Rank $rank): self
    {
        if (!$this->rank->contains($rank)) {
            $this->rank[] = $rank;
        }

        return $this;
    }

    public function removeRank(Rank $rank): self
    {
        if ($this->rank->contains($rank)) {
            $this->rank->removeElement($rank);
        }

        return $this;
    }

    /**
     * @return Collection|Topic[]
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(Topic $topic): self
    {
        if (!$this->topics->contains($topic)) {
            $this->topics[] = $topic;
            $topic->setUser($this);
        }

        return $this;
    }

    public function removeTopic(Topic $topic): self
    {
        if ($this->topics->contains($topic)) {
            $this->topics->removeElement($topic);
            // set the owning side to null (unless already changed)
            if ($topic->getUser() === $this) {
                $topic->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return array (Role|string)[] The user roles
     */
    public function getRoles(): array
    {
        $roles = [];
        foreach ($this->getRank() as $rank) {
            $roles[] = $rank->getName();
        }

        return $roles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->login;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
    }

    /**
     * String representation of object.
     *
     * @see https://php.net/manual/en/serializable.serialize.php
     *
     * @return string the string representation of the object or null
     *
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->login,
            $this->password,
            $this->mail,
            $this->rank,
        ]);
    }

    /**
     * Constructs the object.
     *
     * @see https://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized <p>
     *                           The string representation of the object.
     *                           </p>
     *
     * @return void
     *
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->login,
            $this->password,
            $this->mail,
            $this->rank
            ) = unserialize($serialized, ['allowed_classes' => false]);
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
            $privateMessage->setAuthor($this);
        }

        return $this;
    }

    public function removePrivateMessage(PrivateMessage $privateMessage): self
    {
        if ($this->privateMessages->contains($privateMessage)) {
            $this->privateMessages->removeElement($privateMessage);
            // set the owning side to null (unless already changed)
            if ($privateMessage->getAuthor() === $this) {
                $privateMessage->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Conversation[]
     */
    public function getConversationsStarter(): Collection
    {
        return $this->conversationsStarter;
    }

    public function addConversationStarter(Conversation $conversation): self
    {
        if (!$this->conversationsStarter->contains($conversation)) {
            $this->conversationsStarter[] = $conversation;
            $conversation->setStarter($this);
        }

        return $this;
    }

    public function removeConversationStarter(Conversation $conversation): self
    {
        if ($this->conversationsStarter->contains($conversation)) {
            $this->conversationsStarter->removeElement($conversation);
            // set the owning side to null (unless already changed)
            if ($conversation->getStarter() === $this) {
                $conversation->setStarter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Conversation[]
     */
    public function getConversationsReceiver(): Collection
    {
        return $this->conversationsReceiver;
    }

    public function addConversationReceiver(Conversation $conversation): self
    {
        if (!$this->conversationsReceiver->contains($conversation)) {
            $this->conversationsReceiver[] = $conversation;
            $conversation->setStarter($this);
        }

        return $this;
    }

    public function removeConversationReceiver(Conversation $conversation): self
    {
        if ($this->conversationsReceiver->contains($conversation)) {
            $this->conversationsReceiver->removeElement($conversation);
            // set the owning side to null (unless already changed)
            if ($conversation->getStarter() === $this) {
                $conversation->setStarter(null);
            }
        }

        return $this;
    }
}
