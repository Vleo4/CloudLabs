using Telegram.Bot;
using Telegram.Bot.Types;

namespace am3bot.Controllers.Commands
{
    public interface ICommand
    {
        public TelegramBotClient Client { get; }
        public string Name { get; }
        public async Task Execute(Update update) { }
    }
}
