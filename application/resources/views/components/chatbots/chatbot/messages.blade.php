@foreach ($chatbot->messages as $index => $message)
    <x-chatbots.chatbot.message :$size :content="$message['content']" :role="$message['role']" :chatbot="$chatbot" :preview="$preview" />
@endforeach
