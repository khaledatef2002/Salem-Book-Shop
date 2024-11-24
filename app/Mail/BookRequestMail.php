<?php
namespace App\Mail;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class BookRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    private Book $book;
    private bool $accept;

    /**
     * Create a new message instance.
     */
    public function __construct(Book $book, bool $accept)
    {
        $this->book = $book;
        $this->accept = $accept;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your request for unlocking book: ' . $this->book->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        // Embed the image by attaching it with inline disposition
        return new Content(
            view: 'emails.accept-book-request',
            with: [
                'status' => $this->accept,
                'book' => $this->book,
            ]
        );
    }
}
